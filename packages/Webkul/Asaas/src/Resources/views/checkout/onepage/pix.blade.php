@extends('shop::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pagamento via PIX</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <p class="mb-3">Escaneie o QR Code abaixo para efetuar o pagamento:</p>
                        
                        @if($qrCodeBase64)
                            <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code PIX" class="img-fluid mb-3" style="max-width: 300px;">
                        @endif
                        
                        @if($qrCodePayload)
                            <div class="alert alert-info">
                                <strong>Código PIX Copia e Cola:</strong><br>
                                <code class="pix-code">{{ $qrCodePayload }}</code>
                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyPixCode()">
                                    Copiar
                                </button>
                            </div>
                        @endif
                        
                        @if($invoiceUrl)
                            <a href="{{ $invoiceUrl }}" target="_blank" class="btn btn-info mb-3">
                                Abrir no Asaas
                            </a>
                        @endif
                        
                        <div class="alert alert-warning">
                            <strong>Status:</strong> {{ ucfirst(strtolower($status)) }}
                        </div>
                        
                        <p class="text-muted small">
                            O pedido será confirmado automaticamente após o pagamento.
                            O pagamento via PIX é processado instantaneamente.
                        </p>
                        
                        <div class="mt-4">
                            <a href="{{ route('asaas.pix.status', ['payment_id' => $paymentId]) }}" class="btn btn-primary" id="checkStatus">
                                Verificar Status
                            </a>
                            <a href="{{ route('shop.checkout.cart.index') }}" class="btn btn-secondary">
                                Voltar ao Carrinho
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyPixCode() {
    const code = document.querySelector('.pix-code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        alert('Código PIX copiado!');
    });
}

setInterval(function() {
    fetch('{{ route('asaas.pix.status', ['payment_id' => $paymentId]) }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'CONFIRMED' || data.status === 'RECEIVED') {
                window.location.href = '{{ route('asaas.success') }}';
            }
        });
}, 10000);
</script>
@endpush
@endsection
