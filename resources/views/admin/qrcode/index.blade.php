@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">QR Code Generator</h1>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pindai QR Code Ini</h6>
                <button class="btn btn-sm btn-primary" id="btn-generate"><i class="bi bi-arrow-clockwise"></i> Perbarui QR</button>
            </div>
            <div class="card-body text-center" id="qr-container">
                @if($token)
                    <div id="qr-display" class="mb-3">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($token->token) !!}
                    </div>
                    <p class="text-muted">Kedaluwarsa pada: <span id="expire-time">{{ $token->expires_at }}</span></p>
                @else
                    <div id="qr-display" class="mb-3">
                        <p>Tidak ada token aktif yang ditemukan.</p>
                    </div>
                    <p class="text-muted">Kedaluwarsa pada: <span id="expire-time">-</span></p>
                @endif
                
                <h3 class="mt-4 text-danger" id="timer"></h3>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    let intervalId = null;

    function generateQr() {
        $.ajax({
            url: "{{ route('admin.qr-code.generate') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if(res.success) {
                    let imgUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${res.token}`;
                    $('#qr-display').html(`<img src="${imgUrl}" alt="QR Code" />`);
                    $('#expire-time').text(res.expires_at);
                    
                    // Reset timer to 5 minutes (300 seconds)
                    startTimer(300);
                }
            }
        });
    }

    function startTimer(duration) {
        clearInterval(intervalId);
        let timer = duration, minutes, seconds;
        intervalId = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            $('#timer').text(minutes + ":" + seconds);

            if (--timer < 0) {
                clearInterval(intervalId);
                generateQr(); // Auto regenerate when expired
            }
        }, 1000);
    }

    $('#btn-generate').click(function() {
        generateQr();
    });

    // Initialize timer if token exists, else generate one
    @if($token)
        let expireDate = new Date("{{ $token->expires_at }}").getTime();
        let now = new Date().getTime();
        let diff = Math.floor((expireDate - now) / 1000);
        if (diff > 0) {
            startTimer(diff);
        } else {
            generateQr();
        }
    @else
        generateQr();
    @endif
});
</script>
@endpush
