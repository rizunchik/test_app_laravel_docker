const validator = new JustValidate('#product_form', {
    errorFieldCssClass: 'is-invalid', 
    successFieldCssClass: '', 
});

function toNum(value){
    return parseFloat(String(value).replace(',', '.'));
}

validator
    .addField('[name="name"]', [
        {
            rule: 'required',
            errorMessage: 'Поле обовʼязкове',
        },
        {
            rule: 'minLength',
            value: 4,
            errorMessage: 'Назва повинна мати більше трьох символів.',
        },],{
            errorsContainer: '#validationName'
    })
    .addField('#price', [
        {
            rule: 'required',
            errorMessage: 'Обовʼязкове поле',
        },
        {
            validator: (value) => toNum(value) > 0,
            errorMessage: 'Ціна повинна бути більше 0',
        },
        {
            validator: (value, fields) => {
                const cost = parseFloat(document.querySelector('#cost').value || 0);
                return parseFloat(value) > cost;
        },
            errorMessage: 'Ціна повинна бути більша ніж ціна собівартості',
        },
        {
            validator: (value, fields) => {
                const isDiscount = document.querySelector('#is_discount').checked;
                const discountPrice = parseFloat(document.querySelector('#discount_price').value || 0);
                return !isDiscount || parseFloat(value) > discountPrice;
        },
            errorMessage: 'Ціна повинна бути більша ніж ціна зі знижкою, якщо включено знижку',
        }],{
            errorsContainer: '#validationPrice'
    })
    .addField('#discount_price', [
        {
            validator: (value) => {
                if (!document.querySelector('#is_discount').checked) return true;
                return toNum(value) > 0;
            },
            errorMessage: 'Ціна зі знижкою має бути більше 0, якщо знижка ввімкнена.',
        },
        {
            validator: (value, fields) => {
                const cost = parseFloat(document.querySelector('#cost').value || 0);
                const isDiscount = document.querySelector('#is_discount').checked;
                return !isDiscount || parseFloat(value) > cost;
        },
            errorMessage: 'Ціна зі знижкою повинна бути більша ніж ціна собівартості, якщо включено знижку',
        }],{
            errorsContainer: '#validationDiscountPrice'
    })
    .addField('#cost', [
        {
            validator: (value) => toNum(value) > 0,
            errorMessage: 'Собівартість має бути більше 0',
        },],{
            errorsContainer: '#validationCost'
        });

    validator.onSuccess((event) => {
        console.log(event.target);
        event.target.submit(); 

    });