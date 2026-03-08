@extends('shop::layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pagamento com Cartão de Crédito</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('asaas.card.process') }}" id="cardForm">
                        @csrf
                        
                        <div class="alert alert-info">
                            <i class="fas fa-lock"></i> 
                            Seus dados são processados de forma segura pelo Asaas.
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="number">Número do Cartão *</label>
                            <input type="text" 
                                   id="number" 
                                   name="number" 
                                   class="form-control" 
                                   placeholder="0000 0000 0000 0000"
                                   maxlength="19"
                                   required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="expiry_month">Mês de Expiração *</label>
                                    <select id="expiry_month" name="expiry_month" class="form-control" required>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="expiry_year">Ano de Expiração *</label>
                                    <select id="expiry_year" name="expiry_year" class="form-control" required>
                                        @for($i = date('Y'); $i <= date('Y') + 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="ccv">CVV *</label>
                            <input type="text" 
                                   id="ccv" 
                                   name="ccv" 
                                   class="form-control" 
                                   placeholder="123"
                                   maxlength="4"
                                   required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="holder_name">Nome Impresso no Cartão *</label>
                            <input type="text" 
                                   id="holder_name" 
                                   name="holder_name" 
                                   class="form-control" 
                                   placeholder="Como está no cartão"
                                   maxlength="100"
                                   required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="cpf_cnpj">CPF/CNPJ do Titular *</label>
                            <input type="text" 
                                   id="cpf_cnpj" 
                                   name="cpf_cnpj" 
                                   class="form-control" 
                                   placeholder="000.000.000-00"
                                   required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="address_number">Número do Endereço *</label>
                            <input type="text" 
                                   id="address_number" 
                                   name="address_number" 
                                   class="form-control" 
                                   placeholder="123"
                                   required>
                            <small class="form-text text-muted">
                                Use o mesmo número do endereço de cobrança
                            </small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="address_complement">Complemento (opcional)</label>
                            <input type="text" 
                                   id="address_complement" 
                                   name="address_complement" 
                                   class="form-control" 
                                   placeholder="Apto, Bloco, etc.">
                        </div>
                        
                        <div class="alert alert-secondary">
                            <div class="d-flex justify-content-between">
                                <strong>Total a pagar:</strong>
                                <span class="h4 mb-0">R$ {{ number_format($cart->grand_total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-between">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1" id="payButton">
                                <i class="fas fa-credit-card"></i> Pagar Agora
                            </button>
                            <a href="{{ route('shop.checkout.cart.index') }}" class="btn btn-secondary btn-lg">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardNumber = document.getElementById('number');
    
    cardNumber.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = value;
    });
    
    const cardForm = document.getElementById('cardForm');
    const payButton = document.getElementById('payButton');
    
    cardForm.addEventListener('submit', function(e) {
        payButton.disabled = true;
        payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
    });
});
</script>
@endpush
@endsection
