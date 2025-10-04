const nameEl = document.getElementById('name');
const priceEl = document.getElementById('price');
const isDiscountEl = document.getElementById('is_discount');
const discountPriceEl = document.getElementById('discount_price');
const costEl = document.getElementById('cost');
const saveEl = document.getElementById('save');

function num(el){
    let v = parseFloat(String(el.value).replace(',', '.'));
    return Number.isFinite(v) ? v : 0;
}

function validateWarn(inputEl, feedbackEl ){
    inputEl.classList.add('is-invalid');
    feedbackEl.classList.add('invalid-feedback');
    feedbackEl.classList.remove('d-none');
    saveEl.disabled = true;
    return false;
}
function validateOk(inputEl, feedbackEl ){
    inputEl.classList.remove('is-invalid');
    feedbackEl.classList.remove('invalid-feedback');
    feedbackEl.classList.add('d-none');
    offDisable();
    
}

function offDisable(){
    saveEl.disabled = false;
}

function validate(e) {
    const el = e.target;
    let price = num(priceEl);
    let discountPrice = num(discountPriceEl);
    let cost  = num(costEl);

    var validationPriceMoreThenZeroEl = document.getElementById('validationPriceMoreThenZero');
    var validationCostMoreThenZeroEl = document.getElementById('validationCostMoreThenZero');
    var validationPriceMoreThenDiscountPriceEl = document.getElementById('validationPriceMoreThenDiscountPrice');
    var validationPriceMoreThenCostEl = document.getElementById('validationPriceMoreThenCost');
    var validationDiscMoreThenCostEl = document.getElementById('validationDiscMoreThenCost');
    var validationEmptyNameEl = document.getElementById('validationEmptyName');

    if (nameEl.value.length < 4 && (el === nameEl || el === saveEl)){
        validateWarn(nameEl, validationEmptyNameEl);
        return;
    }else{
        validateOk(nameEl, validationEmptyNameEl);
    }

    if (price <= 0  && (el === priceEl || el === saveEl)){

        validateWarn(priceEl, validationPriceMoreThenZeroEl);
        return;
    }else{

        validateOk(priceEl, validationPriceMoreThenZeroEl);
    }
    
    if (cost <= 0 && (el === costEl || el === saveEl)){

        validateWarn(costEl, validationCostMoreThenZeroEl);
        return;
    }else{

        validateOk(costEl, validationCostMoreThenZeroEl);
    }

    if( price <= cost  && (el === priceEl || el === saveEl)){

        validateWarn(priceEl, validationPriceMoreThenCostEl);
        return;
    }else{
        
        validateOk(priceEl, validationPriceMoreThenCostEl);
    }

    if (isDiscountEl.checked) {

        if( price <= discountPrice  && (el === priceEl || el === saveEl)){
            
            validateWarn(priceEl, validationPriceMoreThenDiscountPriceEl);
            return;
        }else{

            validateOk(priceEl, validationPriceMoreThenDiscountPriceEl);
        }

        if( discountPrice <= cost  && (el === discountPriceEl || el === saveEl)){

            validateWarn(discountPriceEl, validationDiscMoreThenCostEl);
            return;
        }else{
            
            validateOk(discountPriceEl, validationDiscMoreThenCostEl);
        }

    }

}



['onfocus','click'].forEach(event => {
//   nameEl.addEventListener(event, validate);
//   priceEl.addEventListener(event, validate);
//   isDiscountEl.addEventListener(event, validate);
//   discountPriceEl.addEventListener(event,  validate);
//   costEl.addEventListener(event,  validate);
  saveEl.addEventListener(event,  validate);
});

['blur'].forEach(event => {
  nameEl.addEventListener(event, validate);
  priceEl.addEventListener(event, validate);
  isDiscountEl.addEventListener(event, validate);
  discountPriceEl.addEventListener(event,  validate);
  costEl.addEventListener(event,  validate);
});

// ['input','change','click'].forEach(event => {
//       nameEl.addEventListener(event, offDisable);
//       priceEl.addEventListener(event, offDisable);
//       isDiscountEl.addEventListener(event, offDisable);
//       discountPriceEl.addEventListener(event,  offDisable);
//       costEl.addEventListener(event,  offDisable);
//     });

// validate();