const user = {
    email: 'jonathrakoto91400@gmail.com',
    password: 'azertyuiop'
};

const { email, password } = user;

describe('Connected: The Home Page', function() {
    it('Successfully loads', function() {
        cy.visit('/login');
    });
    it('Login Success', function() {
        Cypress.Commands.add('loginByCSRF', (email, password, csrfToken) => {
            cy.request({
                method: 'POST',
                url: '/login',
                failOnStatusCode: false,
                form: true,
                body: {
                    email,
                    password,
                    _csrf_token: csrfToken
                }
            })
        });
        cy.request('/login')
            .its('body')
            .then((body) => {
                const $html = Cypress.$(body);
                const csrf = $html.find("input[name=_csrf_token]").val();

                cy.loginByCSRF(email, password, csrf)
                    .then(() => {
                        cy.visit('/')
                    })
            })
    });

});