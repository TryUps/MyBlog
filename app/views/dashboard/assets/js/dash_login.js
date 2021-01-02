


const inputs = document.querySelectorAll('input[type=text], input[type=password]');
for(let input of inputs){
  input.addEventListener('keyup', (e) => {
    let valid = e.target.checkValidity();
    let icon = e.target.parentElement.querySelector('i');
    if(valid){
      icon.classList.add('colored')
    }else{
      icon.classList.remove('colored');
    }
  });
}

const submitForm = (e) => {
  e.preventDefault();
  let data = new FormData(e.target);

  const login = (data) => fetch('./signin',{
    method: 'POST',
    body: data
  })
  .then(res => res.json())
  .catch(error => console.error(error))

  login(data).then(login => {
    console.log(login);
    if(login){
      setTimeout(() => window.location.href = './dash/', 2000)
    }
  });
}

const loginform = document.querySelector("#myb__login_form");
loginform.addEventListener("submit", submitForm);