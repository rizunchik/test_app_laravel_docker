const priceEl = document.getElementById('price');
const isDiscountEl = document.getElementById('is_discount');
const discountPriceEl = document.getElementById('discount_price');
const costEl = document.getElementById('cost');
const profitEl = document.getElementById('profit');
const marginEl = document.getElementById('margin');

function num(el){
    let v = parseFloat(String(el.value).replace(',', '.'));
    return Number.isFinite(v) ? v : 0;
}

function recompute() {
    let price = num(priceEl);
    let discountPrice = num(discountPriceEl);
    let cost  = num(costEl);
    let profit = 0;
    let margin = 0;

    if(isDiscountEl.checked){
        price = discountPrice;
    }

    if (price > 0 && cost > 0){
        
        profit = (price - cost).toFixed(2);
        margin = (profit * 100 / price).toFixed(2);
        
    }

    profitEl.value = profit;
    marginEl.value = margin;

}

['input','change','click','blur'].forEach(event => {
  priceEl.addEventListener(event, recompute);
  isDiscountEl.addEventListener(event, recompute);
  discountPriceEl.addEventListener(event,  recompute);
  costEl.addEventListener(event,  recompute);
});

recompute();