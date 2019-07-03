const user = {
    pseudo: 'test',
    email: 'test.test@gmail.com',
    password: 'azertyuiop'
};

const { pseudo, email, password } = user;

describe('The Authentication Page', function() {
    before(function(){
        cy.exec('php bin/console d:s:u --force && php bin/console d:f:l')
    });
    it('Successfully loads', function() {
        cy.visit('/login');
    });

    it('Register Success', function() {
        cy.wait(1000);
        cy.get("#_signin").click();
        cy.get("#user_pseudo").type(pseudo);
        cy.get("#user_email").type(email);
        cy.get("#user_password_first").type(password);
        cy.get("#user_password_second").type(password);
        cy.get("#user_termsAccepted").check();
        cy.wait(500);
        cy.get('#signin').submit();
    });

    it('Login with User Registered; Expected Error Message "Account not Actived"', function() {
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
                const csrf  = $html.find("input[name=_csrf_token]").val();

            cy.loginByCSRF(email, password, csrf)
              .then((resp) => {
                  expect(resp.status).to.eq(200);
                  expect(resp.body).to.include("<div class=\"alert alert-danger\">Account isn&#039;t active</div>");
              })
            })
    });
});