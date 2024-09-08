<style>
    .payform-tinkoff {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 2px auto;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        max-width: 250px;
    }
    .payform-tinkoff-row {
        margin: 2px;
        border-radius: 4px;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
        border: 1px solid #DFE3F3;
        padding: 15px;
        outline: none;
        background-color: #DFE3F3;
        font-size: 15px;
    }
    .payform-tinkoff-row:focus {
        background-color: #FFFFFF;
        border: 1px solid #616871;
        border-radius: 4px;
    }
    .payform-tinkoff-btn {
        background-color: #FBC520;
        border: 1px solid #FBC520;
        color: #3C2C0B;
    }
    .payform-tinkoff-btn:hover {
        background-color: #FAB619;
        border: 1px solid #FAB619;
    }
</style>

<script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>
<form class="payform-tinkoff" name="payform-tinkoff" id="payform-tinkoff">
    <input class="payform-tinkoff-row" type="hidden" name="terminalkey" value="TinkoffBankTest">
    <input class="payform-tinkoff-row" type="hidden" name="frame" value="false">
    <input class="payform-tinkoff-row" type="hidden" name="language" value="ru">
    <input class="payform-tinkoff-row" type="hidden" name="receipt" value="">
    <input class="payform-tinkoff-row" type="text" placeholder="Сумма пополнения" name="amount" required>
    <input class="payform-tinkoff-row" type="hidden" placeholder="Номер заказа" name="order">
    <input class="payform-tinkoff-row" type="text" placeholder="Имя плательщика" name="name">
    <input class="payform-tinkoff-row" type="email" placeholder="E-mail" name="email">
    <input class="payform-tinkoff-row payform-tinkoff-btn" type="submit" value="Оплатить">
</form>



<script type="text/javascript">
    const TPF = document.getElementById("payform-tinkoff");

    TPF.addEventListener("submit", function (e) {
        e.preventDefault();
        const {description, amount, email, receipt} = TPF;

        if (receipt) {
            if (!email.value && !phone.value)
                return alert("Поле E-mail не должно быть пустым! ");

            TPF.receipt.value = JSON.stringify({
                "EmailCompany": "info@hack-lair.com",
                "Taxation": "patent",
                "Items": [
                    {
                        "Name": description.value || "Оплата",
                        "Price": amount.value + '00',
                        "Quantity": 1.00,
                        "Amount": amount.value + '00',
                        "PaymentMethod": "full_prepayment",
                        "PaymentObject": "service",
                        "Tax": "none"
                    }
                ]
            });
        }
        pay(TPF);
    })
</script>