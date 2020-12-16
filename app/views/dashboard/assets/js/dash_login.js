


const submitForm = (e) => {
  e.preventDefault();
  let data = new FormData(e.target);

  const login = (data) => fetch('./signin',{
    method: 'POST',
    body: data
  })
  .then(res => res.json())
  .catch(error => console.error(error.msg))

  login(data).then(login => {
    if(login){
      setTimeout(() => window.location.href = './dash/', 500)
    }
  });
}

const loginform = document.querySelector(".myb__loginform");
loginform.addEventListener("submit", submitForm);