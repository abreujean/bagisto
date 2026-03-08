# Gateway de Pagamento Asaas para Bagisto

Integração completa do gateway de pagamento [Asaas](https://asaas.com/) com o sistema de e-commerce Bagisto.

## 📋 Funcionalidades

- ✅ **PIX** - Pagamento instantâneo com QR Code e PIX Copia e Cola
- ✅ **Boleto Bancário** - Geração de boletos com vencimento de 3 dias
- ✅ **Cartão de Crédito** - Processamento de cartão de crédito
- ✅ **Webhooks** - Atualização automática do status do pedido
- ✅ **Ambientes** - Suporte para Sandbox e Produção
- ✅ **Multi-idioma** - Português e Inglês
- ✅ **Transações** - Rastreamento completo de transações

## 🚀 Instalação

### 1. Estrutura do Pacote

O pacote está localizado em: `packages/Webkul/Asaas/`

### 2. Configuração do Composer

O pacote já está registrado no `composer.json` principal do projeto.

### 3. Atualizar Autoloader

```bash
composer dump-autoload
```

### 4. Limpar Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## ⚙️ Configuração

### Configurar no Painel Admin

1. Acesse o painel administrativo do Bagisto
2. Vá em **Configurações** > **Vendas** > **Métodos de Pagamento**
3. Encontre a seção **Asaas**
4. Configure os seguintes campos:

#### Campos Obrigatórios

- **API Key**: Chave de API do Asaas (encontrada no painel do Asaas)
  - Obrigatório quando o método está ativo
- **Ambiente**: `Sandbox` para testes, `Production` para produção
  - Obrigatório quando o método está ativo
- **Token do Webhook**: Token para validar webhooks recebidos do Asaas
  - Obrigatório quando o método está ativo
  - Este token deve ser configurado também no painel do Asaas

#### Campos Opcionais

- **Título**: Nome exibido no checkout
- **Descrição**: Descrição do método de pagamento
- **Imagem**: Logo do método de pagamento
- **Ordem de Classificação**: Ordem de exibição no checkout
- **Gerar automaticamente a fatura**: Cria fatura automaticamente após o pedido
- **Definir o status da fatura após criar**: Status da fatura após geração

#### Métodos de Pagamento Disponíveis

Após configurar o Asaas, 4 métodos de pagamento ficarão disponíveis para ativação individual:

1. **asaas_pix** - PIX com QR Code
2. **asaas_pix_copy_paste** - PIX Copia e Cola
3. **asaas_boleto** - Boleto Bancário
4. **asaas_card** - Cartão de Crédito

## 🔗 Configurar Webhook

### Eventos Recomendados

Configure os seguintes eventos no painel do Asaas:

- `PAYMENT_CONFIRMED` - Pagamento confirmado
- `PAYMENT_RECEIVED` - Pagamento recebido
- `PAYMENT_REFUNDED` - Pagamento estornado
- `PAYMENT_DELETED` - Pagamento cancelado

## 📊 Mapeamento de Status

| Status Asaas | Status Bagisto | Descrição |
|--------------|----------------|-----------|
| PENDING | pending | Aguardando pagamento |
| CONFIRMED | processing | Pagamento confirmado |
| RECEIVED | completed | Pagamento recebido |
| REFUNDED | refunded | Pagamento estornado |
| CANCELLED | canceled | Pagamento cancelado |
| OVERDUE | pending | Pagamento em atraso |

## 💡 Como Usar

### 1. Cliente faz checkout

1. Cliente seleciona produtos e vai para o checkout
2. Cliente escolhe método de pagamento (PIX, Boleto ou Cartão)
3. Cliente é redirecionado para a página de pagamento

### 2. PIX

- Cliente é redirecionado para página com QR Code
- Cliente pode escanear o QR Code ou usar PIX Copia e Cola
- Status é verificado automaticamente a cada 10 segundos
- Pedido é confirmado automaticamente após pagamento

### 3. Boleto

- Cliente é redirecionado para página com link do boleto
- Cliente pode baixar ou imprimir o boleto
- Vencimento configurado para 3 dias
- Pedido é processado após compensação (1-3 dias úteis)

### 4. Cartão de Crédito

- Cliente preenche dados do cartão
- Pagamento é processado via Asaas
- Pedido é confirmado imediatamente após aprovação
- Transação é salva no sistema

## 🧪 Testando

### Ambiente Sandbox

Use o ambiente Sandbox para testes sem processar pagamentos reais:

1. Vá em **Configurações** > **Vendas** > Métodos de Pagamento** > Asaas**
2. No campo **Ambiente**, selecione `Sandbox`
3. Use a API Key do ambiente Sandbox (obtida em sandbox.asaas.com)
4. Salve as configurações

### Testes Automáticos do Asaas

Para testar PIX no sandbox, use valores específicos:
- **R$ 0,01** → Aprovação automática
- **R$ 0,05** → Recusa automática

### Fluxo de Testes

1. Configurar Asaas no ambiente Sandbox
2. Criar um pedido de teste
3. Selecionar método de pagamento PIX
4. Usar um dos valores de teste (R$ 0,01 ou R$ 0,05)
5. Verificar se o status do pedido é atualizado corretamente

## 📁 Estrutura do Pacote

```
packages/Webkul/Asaas/
├── composer.json
├── Config/
│   └── paymentmethods.php
└── src/
    ├── Http/
    │   ├── routes.php
    │   └── Controllers/
    │       ├── AsaasController.php
    │       ├── PixController.php
    │       ├── BoletoController.php
    │       └── CardController.php
    ├── Payment/
    │   ├── Asaas.php (Classe base)
    │   ├── Pix.php
    │   ├── PixCopyPaste.php
    │   ├── Boleto.php
    │   └── Card.php
    ├── Helpers/
    │   ├── AsaasHttpClient.php
    │   ├── AsaasHelper.php
    │   └── WebhookHelper.php
    ├── Listeners/
    │   └── Transaction.php
    ├── Providers/
    │   ├── AsaasServiceProvider.php
    │   ├── ModuleServiceProvider.php
    │   └── EventServiceProvider.php
    └── Resources/
        ├── manifest.php
        ├── views/
        │   └── checkout/onepage/
        │       ├── pix.blade.php
        │       ├── boleto.blade.php
        │       └── card.blade.php
        └── lang/
            ├── en/app.php
            └── pt_BR/app.php
```

## 🔒 Segurança

1. **HTTPS**: Certifique-se de usar HTTPS em produção
2. **Validação de Webhook**: Implementar validação de token do webhook
3. **Sanitização de Dados**: Sanitizar todos os dados recebidos
4. **Logs**: Implementar logs para debugging de webhooks

## 📝 Observações

- **Tokenização de Cartão**: Para produção, implementar tokenização do Asaas
- **Retentativas**: Implementar lógica de retentativas para pagamentos
- **Timeouts**: Timeouts configurados para 30 segundos
- **Rate Limiting**: Respeitar rate limits da API do Asaas

## 🐛 Troubleshooting

### Pagamentos não aparecem

1. Verifique se o método está ativo no painel admin
   - **Configurações** > **Vendas** > **Métodos de Pagamento** > Asaas
   - Certifique-se de que o campo "Status" está marcado
2. Verifique se a API Key está configurada
   - O campo "API Key" deve ser preenchido
   - O método só aparecerá se a API Key estiver configurada
3. Verifique o ambiente configurado
   - Sandbox ou Production correspondente à sua API Key

### Webhooks não funcionam

1. Verifique se a URL do webhook está acessível
   - Teste a URL: `https://seu-dominio.com/asaas/webhook`
   - Deve retornar um erro 403 se o token não for enviado
2. Verifique se o token do webhook está correto
   - Token no painel Asaas deve ser igual ao configurado no painel Bagisto
   - Verifique o header `asaas-access-token` está sendo enviado
3. Verifique se o CSRF está desabilitado
   - A rota `/asaas/webhook` está configurada sem CSRF
   - Isso é tratado automaticamente no arquivo `routes.php`
4. Verifique os logs do Laravel
   ```bash
   php artisan log
   ```
   - Procure por erros relacionados a webhooks Asaas

### Erro de conexão com Asaas

1. Verifique se a API Key está correta
   - Obtenha a chave correta no painel Asaas
   - Certifique-se de estar usando a API Key do ambiente correto
2. Verifique se está usando o ambiente correto
   - Sandbox: `sandbox.asaas.com`
   - Production: `asaas.com`
   - API Key de Sandbox não funciona em Production e vice-versa
3. Verifique se o servidor tem acesso à API do Asaas
   - Teste a conexão do servidor
   - Verifique regras de firewall/proxy

### Erro "Method Not Available"

1. Verifique se todos os campos obrigatórios estão preenchidos
   - API Key
   - Ambiente
   - Token do Webhook
2. Verifique se o canal está configurado
   - Em ambientes multi-canal, configure as credenciais por canal

## 🌟 Dicas de Configuração

### Multi-canal

Se você tem múltiplos canais configurados no Bagisto:

1. Selecione o canal desejado no topo da página de configuração
2. Configure as credenciais específicas daquele canal
3. Cada canal pode ter suas próprias credenciais Asaas

### Ambiente de Desenvolvimento

Para desenvolvimento:

1. Use o ambiente Sandbox
2. Use valores de teste (R$ 0,01 para aprova, R$ 0,05 para recusa)
3. Não use credenciais de produção em desenvolvimento

### Migrando de .env para Admin

Se você anteriormente configurava via `.env`:

1. Acesse o painel admin
2. Copie as credenciais do seu arquivo `.env`
3. Cole nos campos apropriados em **Configurações** > **Vendas** > **Métodos de Pagamento** > Asaas**
4. Remova as linhas do arquivo `.env`
5. Limpe os caches: `php artisan config:clear`

## 📄 Licença

MIT

## 🤝 Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.

## 📞 Suporte

- **Documentação Asaas**: https://docs.asaas.com
- **Issues**: Abra issues no repositório do projeto

---

Desenvolvido com ❤️ para comunidade Bagisto Brasil
