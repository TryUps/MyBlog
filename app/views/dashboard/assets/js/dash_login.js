


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
      setTimeout(() => window.location.href = './dash/', 300)
    }
  });
}

const loginform = document.querySelector("#myb__login_form");
loginform.addEventListener("submit", submitForm);