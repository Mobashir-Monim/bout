@if (sizeof($helper->formulaHelper->access_list) > 1)
    <select onchange="changeEnterprisePart()" id="enterprise-part" class="form-control border-top-0 border-right-0 border-left-0 px-0 custom-select-lg mb-3">
        <option value="">Please select a department</option>
        @foreach ($helper->formulaHelper->access_list as $part => $access_levels)
            <option value="{{ $part }}">{{ $part }}</option>
        @endforeach
    </select>
@else
    <h5>{{ array_keys($helper->formulaHelper->access_list)[0] }}</h5>
    <input type="hidden" value="{{ array_keys($helper->formulaHelper->access_list)[0] }}" id="enterprise-part">
@endif