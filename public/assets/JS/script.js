const registerSubmit = document.querySelector('.register-submit')
const loginSubmit = document.querySelector('.login-submit')
const registerForm = document.getElementById('register-form')
const loginForm = document.getElementById('login-form')

/*const affichageLoginOff = document.getElementById('login-off')
affichageLoginOff.style.display = "block"

const affichageLoginOn = document.getElementById('login-on')
affichageLoginOn.style.display = "none"*/

document.addEventListener('DOMContentLoaded', function () {

    registerForm.addEventListener('submit', (event) => {
        event.preventDefault()
        fetch('/register', {
            method: 'POST',
            body: new FormData(registerForm)
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    setTimeout(() => {
                        const modal = document.querySelector('#modal-center-2');
                        modal.classList.remove('uk-open');
                        modal.classList.add('uk-close');
                    }, 800);
                    setTimeout(() => {                        
                        UIkit.notification({ message: data.message_success_register, status: 'success', pos: 'top-right' })
                    }, 1200);
                }

                if (data.errorsRegister) {
                    if (data.errorsRegister.email) {
                        const afficheErrorsEmail = document.querySelector('#errorsemail');
                        afficheErrorsEmail.setAttribute("placeholder", data.errorsRegister.email);
                    }
                    if (data.errorsRegister.password) {
                        const afficheErrorsPasswordRegister = document.querySelector('#errorspasswordregister');
                        afficheErrorsPasswordRegister.setAttribute("placeholder", data.errorsRegister.password);
                    }
                    if (data.errorsRegister.username) {
                        const afficheErrorsUsername = document.querySelector('#errorsusername');
                        afficheErrorsUsername.setAttribute("placeholder", data.errorsRegister.username);
                    }
                    if (data.errorsRegister.firstname) {
                        const afficheErrorsFirstname = document.querySelector('#errorsfirstname');
                        afficheErrorsFirstname.setAttribute("placeholder", data.errorsRegister.firstname);
                    }
                    if (data.errorsRegister.lastname) {
                        const afficheErrorsLastname = document.querySelector('#errorslastname');
                        afficheErrorsLastname.setAttribute("placeholder", data.errorsRegister.lastname);
                    }
                    if (data.errorsRegister.localisation) {
                        const afficheErrorsLocalisation = document.querySelector('#errorslocalisation');
                        afficheErrorsLocalisation.setAttribute("placeholder", data.errorsRegister.localisation);
                    }
                    if (data.errorsRegister.phone_number) {
                        const afficheErrorsPhone = document.querySelector('#errorsphone');
                        afficheErrorsPhone.setAttribute("placeholder", data.errorsRegister.phone_number);
                    }
                    if (data.errorsRegister.birthdate) {
                        const afficheErrorsBirthdate = document.querySelector('#errorsbirthdate');
                        afficheErrorsBirthdate.setAttribute("placeholder", data.errorsRegister.birthdate);
                    }

                }

                if (data.status === 'error') {
                    UIkit.notification({ message: data.message_error_register, status: 'warning', pos: 'top-right' })
                }

            })

    })

    loginForm.addEventListener('submit', (event) => {
        event.preventDefault()
        fetch('/login', {
            method: 'POST',
            body: new FormData(loginForm)
        })
            .then(res => res.json())
            .then(data => {
                if (data.status_login === 'success') {
                    setTimeout(() => {
                        const modal = document.querySelector('#modal-center-1');
                        modal.classList.remove('uk-open');
                        modal.classList.add('uk-close');
                    }, 800);

                    setTimeout(() => {
                        UIkit.notification({ message: data.message_success, status: 'success', pos: 'top-right' })
                    }, 1200);

                    /*affichageLoginOff.style.display = "none"
                    affichageLoginOn.style.display = "block"*/
                }

                if (data.errorsLogin) {
                    if (data.errorsLogin.identifiant) {
                        const afficheErrorsIdentifiant = document.querySelector('#errorsidentifiant');

                        afficheErrorsIdentifiant.setAttribute("placeholder", data.errorsLogin.identifiant);
                    }
                    if (data.errorsLogin.password) {
                        const afficheErrorsPassword = document.querySelector('#errorspassword');
                        afficheErrorsPassword.setAttribute("placeholder", data.errorsLogin.password);
                    }

                }

                if (data.status_login === 'errors') {
                    UIkit.notification({ message: data.message_error, status: 'warning', pos: 'top-right' })
                }
            })
    })

})
