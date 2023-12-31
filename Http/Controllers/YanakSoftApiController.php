<?php

    namespace Modules\YanakSoftApi\Http\Controllers;

    use App\Helpers\WebsiteHelper;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Str;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\YanakSoftApi\Services\ApiService;
    use Modules\YanakSoftApi\Services\ConnectionService;

    class YanakSoftApiController extends Controller
    {
        public function postOrder($id)
        {
            $order = Order::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($order);

            $service        = new ApiService(new ConnectionService());
            $token          = $service->getToken();
            $sessionID      = $order->id . "-" . Str::uuid();
            $total          = $order->total_discounted;
            $userEmail      = $order->email;
            $userIp         = request()->ip();
            $paymentMapping = ['cash_on_delivery' => 0, 'bank_transfer' => 1, 'mypos' => 2];
            $paymentMethod  = 0;
            $warehouseId    = 0;
            if (in_array($order->payment->type, $paymentMapping)) {
                $paymentMethod = $paymentMapping[$order->payment->type];
            }
            $addedProducts = [];
            foreach ($order->order_products as $orderProduct) {
                $additions = [];
                foreach ($orderProduct->additives as $additive) {
                    $additions[] = ['comment_type' => 1, 'id' => $additive->productAdditive->stk_idnumb, 'quantity' => $additive->quantity, 'price' => $additive->productAdditive->price];
                }

                foreach ($orderProduct->additiveExcepts as $additive) {
                    $text = 'Без: ' . $additive->productAdditive->title;
                    $additions[] = ['comment_type' => 8, 'text' => $text, 'id' => 0, 'quantity' => 0, 'price' => 0];
                }

                $addedProduct = $service->sendItemToCart($sessionID, $orderProduct->product->stk_idnumb, $orderProduct->product_quantity, $additions, $orderProduct->vat_applied_discounted_price);
                if (is_null($addedProduct)) {
                    return '1';
                }
                $akey = $this->generateArrayKey($orderProduct->product->stk_idnumb, $orderProduct->vat_applied_discounted_price);
                if (array_key_exists($akey, $addedProducts)) {
                    $addedProducts[$akey]['quantity'] += $addedProduct['quantity'];
                } else {
                    $addedProducts[$akey] = $addedProduct;
                }

                foreach ($orderProduct->productCollection as $productCollection) {
                    $addedProduct = $service->sendItemToCart($sessionID, $productCollection->product->stk_idnumb, $productCollection->quantity, [], $productCollection->price);
                    if (is_null($addedProduct)) {
                        return '2';
                    }

                    $akey = $this->generateArrayKey($productCollection->product->stk_idnumb, $productCollection->price);
                    if (array_key_exists($akey, $addedProducts)) {
                        $addedProducts[$akey]['quantity'] += $addedProduct['quantity'];
                    } else {
                        $addedProducts[$akey] = $addedProduct;
                    }
                }
            }
            $cart = json_decode($service->showStocksInCart(["sessionID" => $sessionID, "customerID" => "0"]));

            if (is_null($cart) || isset($cart->error) || !isset($cart->cart)) {
                return 'error';
            } else {
                $cart     = (array)$cart->cart;
                $cartSame = true;
                foreach ($cart['items'] as $cartItem) {
                    $cKey = $this->generateArrayKey($cartItem->stock_id, $cartItem->price);
                    if (!isset($addedProducts[$cKey]) || $this->compareProductsQuantities($addedProducts[$cKey]['quantity'], $cartItem->quantity)) {
                        $cartSame = false;
                        break;
                    }
                }

                if ($cartSame && $service->createOrder($sessionID, $userIp, $warehouseId, $userEmail, $total, $paymentMethod)) {
                    $order->update(['sent_to_yanak_at' => Carbon::now()]);
                    $order->history()->create(['activity_name' => 'Изпращане на поръчката към Янак на '. Carbon::parse($order->sent_to_yanak_at)->format('d.m.Y H:i:s').' от '. \Auth::user()->name]);

                    return redirect()->route('admin.shop.orders.edit', ['id' => $order->id])->with('success-message', 'Успешно изпращане на поръчката към Янак!');
                }

                return redirect()->route('admin.shop.orders.edit', ['id' => $order->id])->withErrors(['Внимание! Поръчката не е изпратена. Моля, опитайте отново по-късно.']);
            }
        }

        private function compareProductsQuantities($quantityOne, $quantityTwo)
        {
            $quantityOne = number_format($quantityOne, 2, '.', '');
            $quantityTwo = number_format($quantityTwo, 2, '.', '');

            return $quantityOne != $quantityTwo;
        }
        private function generateArrayKey($partOne, $partTwo)
        {
            $partTwo = number_format($partTwo, 2, '.', '');

            return $partOne . "_" . (string)$partTwo;
        }
    }
