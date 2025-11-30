// Client-side: fetch CSRF token and attach to forms that have hidden input with id csrf_token
document.addEventListener('DOMContentLoaded', ()=> {
  fetch('/src/get_csrf.php').then(r=>r.json()).then(data=>{
    if(data && data.token){
      document.querySelectorAll('input[name=csrf_token]').forEach(i=>i.value = data.token);
    }
  }).catch(()=>{});

  document.querySelectorAll('form[novalidate]').forEach(form=>{
    form.addEventListener('submit', (e)=>{
      if(!form.checkValidity()){
        e.preventDefault();
        alert('Please fill the form correctly.');
      }
    });
  });
});
