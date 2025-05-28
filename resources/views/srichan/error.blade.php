<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แจ้งเตือน</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'ไม่พบโค้ดที่ระบุ',
            text: '{{ $message }}',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.href = '{{ $redirect_url }}';
        });
    </script>
</body>
</html>
