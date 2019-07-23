const user = {
    email: 'jonathrakoto91400@gmail.com',
    password: 'azertyuiop'
};

const { email, password } = user;

describe('Connected: Demand Post', function() {
    beforeEach(() => {
        cy.exec('php bin/console d:s:u --force && php bin/console d:f:l');
        cy.visit('/login');
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
    it('Demand a Post', function () {
        cy.get('h5')
            .contains('Netflix')
            .parents('.margin-card')
            .contains('Request')
            .click()
    })
});