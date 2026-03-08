@extends('shop::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pagamento via Boleto</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <p class="mb-3">Seu boleto foi gerado com sucesso!</p>
                        
                        @if($dueDate)
                            <p class="mb-3">
                                <strong>Data de Vencimento:</strong> 
                                {{ \Carbon\Carbon::parse($dueDate)->format('d/m/Y') }}
                            </p>
                        @endif
                        
                        <div class="d-flex flex-column gap-2 mb-3 justify-content-center">
                            @if($invoiceUrl)
                                <a href="{{ $invoiceUrl }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-file-invoice"></i> Abrir Boleto
                                </a>
                            @endif
                            
                            @if($bankSlipUrl)
                                <a href="{{ $bankSlipUrl }}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-print"></i> Imprimir Boleto
                                </a>
                            @endif
                        </div>
                        
                        <div class="alert alert-warning">
                            <strong>Status:</strong> {{ ucfirst(strtolower($status)) }}
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Atenção:</strong>
                            <ul class="mb-0 mt-2">
                                <li>O pedido será processado após a compensação do boleto (1-3 dias úteis)</li>
                                <li>Guarde o código do banco para conferência</li>
                                <li>O vencimento é de 3 dias após a emissão</li>
                            </ul>
                        </div>
                        
                        <div class="mt-4">
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
@endsection
