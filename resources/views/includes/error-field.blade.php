@if($errors->get($fieldName))
<div><font size="2.0" style="italic" color="red"><i>{{ $errors->first($fieldName) }}</i></font></div>
@endif