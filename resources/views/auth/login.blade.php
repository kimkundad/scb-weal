{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <title>เข้าสู่ระบบ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  {{-- Metronic CSS --}}
  <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

  {{-- Font (Prompt) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap&subset=thai" rel="stylesheet">
  <style>
    :root { --bs-font-sans-serif: 'Prompt', system-ui, -apple-system,'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans Thai', sans-serif; }
    body { font-family: var(--bs-font-sans-serif); }
  </style>
</head>

<body id="kt_body" class="app-blank app-blank">
  {{-- Theme mode setup (ตามต้นฉบับ Metronic) --}}
  <script>
    var defaultThemeMode="light",themeMode;
    if(document.documentElement){
      if(document.documentElement.hasAttribute("data-theme-mode")){
        themeMode=document.documentElement.getAttribute("data-theme-mode");
      }else{
        themeMode=localStorage.getItem("data-theme")!==null?localStorage.getItem("data-theme"):defaultThemeMode;
      }
      if(themeMode==="system"){ themeMode=window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light"; }
      document.documentElement.setAttribute("data-theme", themeMode);
    }
  </script>

  <!--begin::Root-->
  <div class="d-flex flex-column flex-root" id="kt_app_root">

    <!--begin::Authentication - Sign-in-->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

      <!--begin::Body (ซ้าย)-->
      <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

        <!--begin::Form container-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">

          <!--begin::Wrapper-->
          <div class="w-lg-500px p-10">

            <!--begin::Form-->
            <form class="form w-100" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
              @csrf

              <!--begin::Heading-->
              <div class="text-center mb-11">
                <img src="{{ url('img/new_logo_toyata-logo.png') }}" class="img-fluid"/>
              </div>


              <!--begin::Input group-->
              <div class="fv-row mb-8">
                {{-- ใช้ username ตามของเดิมในโปรเจกต์คุณ (ถ้าใช้ email ให้เปลี่ยน name เป็น email) --}}
                <input type="text"
                       placeholder="Username"
                       name="username"
                       value="{{ old('username') }}"
                       autocomplete="username"
                       autofocus
                       class="form-control bg-transparent @error('username') is-invalid @enderror" />
                @error('username')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="fv-row mb-3">
                <input type="password"
                       placeholder="Password"
                       name="password"
                       autocomplete="current-password"
                       class="form-control bg-transparent @error('password') is-invalid @enderror" />
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <!--end::Input group-->

              <!--begin::Wrapper-->
              <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <label class="form-check form-check-custom form-check-solid">
                  <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                  <span class="form-check-label">จำฉันไว้</span>
                </label>

                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="link-primary">ลืมรหัสผ่าน?</a>
                @endif
              </div>
              <!--end::Wrapper-->

              <!--begin::Submit button-->
              <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-danger">
                  <span class="indicator-label">เข้าสู่ระบบ</span>
                  <span class="indicator-progress">กำลังตรวจสอบ...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                  </span>
                </button>
              </div>
              <!--end::Submit button-->


            </form>
            <!--end::Form-->

          </div>
          <!--end::Wrapper-->

        </div>
        <!--end::Form container-->

        <!--begin::Footer links-->
        <div class="d-flex flex-center flex-wrap px-5">
          <div class="d-flex fw-semibold text-primary fs-base">


          </div>
        </div>
        <!--end::Footer links-->

      </div>
      <!--end::Body-->

      <!--begin::Aside (ขวา: รูป/แบรนด์)-->
      <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
           style="background-image: url({{ url('img/report-with-sm.png') }})">

      </div>
      <!--end::Aside-->

    </div>
    <!--end::Authentication - Sign-in-->

  </div>
  <!--end::Root-->

  {{-- Metronic JS --}}
  <script>var hostUrl = "{{ url('assets') }}/";</script>
  <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
  <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>

  {{-- ถ้าต้องใช้สคริปต์หน้าล็อกอินของ Metronic ค่อยเปิดบรรทัดล่างนี้ --}}
  {{-- <script src="{{ url('assets/js/custom/authentication/sign-in/general.js') }}"></script> --}}

</body>
</html>
