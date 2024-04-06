


 function showForm(userType) {
      document.getElementById('designer-form').style.display = userType === 'designer' ? 'block' : 'none';
      document.getElementById('client-form').style.display = userType === 'client' ? 'block' : 'none';
}
