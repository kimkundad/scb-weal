<link rel="icon" type="image/png" sizes="32x32" href="{{ url('img/favicon_v5.png') }}" />

{{-- Fonts --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-uL2r6XkP4R4IZa9Vkq+mjkdA3q8sbmJgzP4qzw4OaAn1pkJ6xE9Z7IUyV3z+gL7iX2Vlo+e2ipP4RJTrjBn5xg=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Vendor styles (เช่น Datatables) --}}
<link href="{{ url('/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

{{-- Global styles (Metronic) --}}
<link href="{{ url('/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

{{-- jQuery (ถ้าจำเป็นต้องใช้ใน <head>) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
  :root{
    --bs-font-sans-serif: 'Prompt','Inter',system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans Thai',sans-serif;
  }
  body, h1, h2, h3, h4, h5, h6, span, p, li, strong, option, label, input, a, b{
    font-family: var(--bs-font-sans-serif) !important;
  }
</style>
