<script>
  // Theme mode (ของ Metronic)
  var defaultThemeMode = "light";
  var themeMode;
  if (document.documentElement){
    if (document.documentElement.hasAttribute("data-theme-mode")){
      themeMode = document.documentElement.getAttribute("data-theme-mode");
    } else {
      themeMode = localStorage.getItem("data-theme") ?? defaultThemeMode;
    }
    if (themeMode === "system"){
      themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }
    document.documentElement.setAttribute("data-theme", themeMode);
  }
</script>

<script>var hostUrl = "assets/";</script>

{{-- Global JS (Metronic) --}}
<script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ url('assets/js/scripts.bundle.js') }}"></script>

{{-- Vendors (หน้าไหนใช้ Datatables/Lightbox ค่อยเปิด) --}}
<script src="{{ url('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ url('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

{{-- ตัวอย่าง custom JS รวม (ถ้าไม่ใช้ลบออกได้) --}}
<script src="{{ url('assets/js/custom/apps/file-manager/list.js') }}"></script>
<script src="{{ url('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ url('assets/js/custom/widgets.js') }}"></script>
<script src="{{ url('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ url('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ url('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ url('assets/js/custom/utilities/modals/users-search.js') }}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- Flash message (SweetAlert) --}}
<script>
  @if ($message = Session::get('add_success'))
    Swal.fire({ text:"ระบบได้ทำการอัพเดทข้อมูลสำเร็จ!", icon:"success", buttonsStyling:false, confirmButtonText:"OK", customClass:{confirmButton:"btn btn-primary"} });
  @endif
  @if ($message = Session::get('edit_success'))
    Swal.fire({ text:"ระบบได้ทำการอัพเดทข้อมูลสำเร็จ!", icon:"success", buttonsStyling:false, confirmButtonText:"OK", customClass:{confirmButton:"btn btn-primary"} });
  @endif
  @if ($message = Session::get('del_success'))
    Swal.fire({ text:"ระบบได้ทำการลบข้อมูลสำเร็จ!", icon:"success", buttonsStyling:false, confirmButtonText:"OK", customClass:{confirmButton:"btn btn-primary"} });
  @endif
  @if ($message = Session::get('edit_error'))
    Swal.fire({ text:"ไม่สามารถลบรายการนี้ได้!", icon:"error", buttonsStyling:false, confirmButtonText:"OK", customClass:{confirmButton:"btn btn-primary"} });
  @endif
</script>
