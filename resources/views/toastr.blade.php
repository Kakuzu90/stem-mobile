<script>

    @if (Session::get('status'))
        toastr['success']('You have successfully logged in to E-Learning Management System. Now you can start to explore!', '👋 Welcome back {{ auth()->user()->name }}!', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
    @endif

    @if ($message = Session::get('success'))
        toastr['success']('{{ $message[1] }}', '{{ $message[0] }}', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
    @endif

    @if ($message = Session::get('update'))
        toastr['warning']('{{ $message[1] }}', '{{ $message[0] }}', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
    @endif

    @if ($message = Session::get('error'))
        toastr['error']('{{ $message[1] }}', '{{ $message[0] }}', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
    @endif

    @if ($message = Session::get('destroy'))
        toastr['error']('{{ $message[1] }}', '{{ $message[0] }}', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
    @endif

</script>