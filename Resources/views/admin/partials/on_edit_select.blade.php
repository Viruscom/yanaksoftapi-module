<div class="form-group">
    <label for="{{ $fieldName }}" class="control-label col-md-3 {{ isset($labelClass) ? $labelClass : '' }}">@if(isset($required) && $required === true)
            <span class="text-purple">* </span>
        @endif{{ $label }}:</label>
    <div class="col-md-3 {{ isset($class) ? $class : '' }}">
        <select id="{{ $fieldName }}" class="form-control select2" name="{{ $fieldName }}">
            @if(isset($withPleaseSelect))
                <option value="">@lang('admin.common.please_select')</option>
            @endif
            @foreach($models as $pmodel)
                <option value="{{ $pmodel->stk_idnumb }}" {{($pmodel->stk_idnumb === old($fieldName) || $pmodel->stk_idnumb === $modelId) ? 'selected': ''}}>  {{ $pmodel->stk_name}}</option>
            @endforeach
        </select>
    </div>
</div>
