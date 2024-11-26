document.getElementById('signup-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
  
    const name = e.target.name.value;
    const email = e.target.email.value;
    const password = e.target.password.value;
    const confirmPassword = e.target.confirm_password.value;
  
    if (password !== confirmPassword) {
      alert('Passwords do not match!');
      return;
    }
  
    const response = await fetch('/signup', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, password }),
    });
  
    const result = await response.text();
    alert(result);
  });
  
  document.getElementById('login-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
  
    const email = e.target.email.value;
    const password = e.target.password.value;
  
    const response = await fetch('/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });
  
    const result = await response.json();
    alert(result.message);
  });
  
  