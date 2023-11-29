<div class="form-group">
    <label for="{{ $fieldName }}" class="control-label col-md-3 {{ isset($labelClass) ? $labelClass : '' }}"><span class="text-purple">* </span>{{ $label }}:</label>
    <div class="col-md-3 {{ isset($class) ? $class : '' }}">
        <select id="{{ $fieldName }}" class="form-control select2" name="{{ $fieldName }}">
            @if(isset($withPleaseSelect))
                <option value="">@lang('admin.common.please_select')</option>
            @endif
            @foreach($models as $model)
                <option value="{{ $model->stk_idnumb }}" {{($model->stk_idnumb === old($fieldName)) ? 'selected': ''}}>  {{ $model->stk_name}} - {{ $model->code}}</option>
            @endforeach
        </select>
    </div>
</div>
