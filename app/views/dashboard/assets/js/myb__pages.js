"use strict";

(() => {
  const MybPages = function({ element = 'body', folder = './pages/' }){

    this.el = document.querySelector(element);
    this.folder = folder;

    let hash = window.location.hash;
    this.hash = hash.split("#!/").pop();

    //return this.load();
  }

  MybPages.prototype.load = function(){
    let el = this.el;
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if(request.readyState < 4) {
          // handle preload
          return;
      }
      if(request.status !== 200) {
          // handle error
          return;
      }
    }
    request.open('GET', this.folder + this.hash, true);
    request.send('');

    request.onload = (e) => {
      document.querySelector('main').innerHTML = request.responseText;
    }
  }

  MybPages.prototype.go = function(page = '#!/'){
    let stateObj = { id: "100" }; 
            window.history.replaceState(stateObj, 
                "Page 3", "/answer#page3.html"); 
    window.history.replaceState({}, '#!/hash', page); 
  }

  const router = new MybPages({
    element: "#dynamic-container",
    folder : "./"
  });

  window.addEventListener("hashchange", MybPages, false);

  window.onhashchange;
})();