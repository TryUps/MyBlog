class Selector extends HTMLElement {
  constructor(){
    super()
    const el = this;
    const shadow = this.attachShadow({ mode: 'closed' })
    const defaultOption = document.createElement('span');
    defaultOption.className = 'default'
    const content = this.innerHTML;
    defaultOption.textContent = this.querySelector('item[default], item:first-child').textContent;
    const option = document.createElement('div')
    el.setAttribute('value', this.querySelector('item[default], item:first-child').getAttribute('value'));
    option.className = 'option-list';
    option.innerHTML = content
    this.innerHTML = null

    const style = document.createElement('style');
    style.textContent = `
      :host {
        display: flex;
        font-family: 'Helvetica', Arial, sans-serif;
        position: relative;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 25px;
        border: 1px solid #ccc;
        padding: 6px 10px;
        min-width: 150px;
        width: 220px;
        height: 30px;
        cursor: pointer;
        transition: border .5s;
      }
      :host(:hover), :host(:focus-within) {
        border-color:#0A0C45;
      }
      
      * {
        box-sizing: border-box;
        user-select: none;
        -webkit-user-select: none;
        cursor: pointer;
      }

      .default {
        text-align: center;
      }

      .option-list {
        position: absolute;
        display: flex;
        width: calc(100% - 0px);
        visibility: hidden;
        flex-direction: column;
        background: rgba(255,255,255,0.5);
        min-height: 30px;
        max-height: 160px;
        border-radius: 6px;
        z-index: 999999;
        border-top: 1px solid rgba(255,255,255, 0.2);
        border-left: 1px solid rgba(255,255,255, 0.2);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
        overflow-y: auto;
      }

      .option-list.show {
        visibility: visible !important;
      }


      .option-list > item {
        display: flex;
        align-items: flex-start;
        padding: 10px 10px;

        border-bottom: 1px solid rgba(255,255,255, 0.3);
      }
      
      .option-list > item:hover {
        background-color: rgba(0,0,0,0.1);
      }

      .option-list > item[disabled] {
        opacity: 0.5;
        cursor: default;
      }
    `;


    shadow.appendChild(style)
    shadow.appendChild(defaultOption)
    shadow.appendChild(option)

    const optionlist = shadow.querySelector('.option-list')
    if(this.getAttribute('mode') === 'top'){
      optionlist.style.bottom = 'calc(100% + 6px)';
    }else{
      optionlist.style.top = '102%';
    }
    this.addEventListener('click', function(e){
      optionlist.classList.toggle('show');
    });
    const itemList = optionlist.querySelectorAll('item:not([disabled])')
    for(let item of itemList){
      item.addEventListener('click', function(e){
        el.setAttribute('value', this.getAttribute('value'));
        shadow.querySelector('span.default').textContent = this.textContent
      });
    }

  }
}

customElements.define('custom-selector', Selector)