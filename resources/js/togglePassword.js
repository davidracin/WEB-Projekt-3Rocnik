// Function to toggle password visibility
console.log('togglePassword.js loaded');
window.togglePassword = function(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.querySelector('.show-icon').textContent = '🙈';
    } else {
        input.type = 'password';
        btn.querySelector('.show-icon').textContent = '👁️';
    }
};
