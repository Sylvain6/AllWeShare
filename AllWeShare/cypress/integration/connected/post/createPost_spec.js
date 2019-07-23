const user = {
    email: 'jonathrakoto91400@gmail.com',
    password: 'azertyuiop'
};

const { email, password } = user;

const post = {
    title: 'Spotify Account',
    description: 'Share my Spotify Account',
    organizationName: 'Spotify',
    organizationPlace: "3",
    organizationUsername: email,
    organizationPassword: password
};

const { title, description, organizationName, organizationPlace, organizationUsername, organizationPassword } = post;

describe('Connected: Create Post', function() {
    beforeEach(() => {
        cy.exec('php bin/console d:s:u --force && php bin/console d:f:l')
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

    it('Create Post Modal', function() {
        cy.wait(1000);
        cy.get('#share').click();
        cy.get('#post_title').type(title);
        cy.get('#post_description').type(description);
        cy.get('#post_organization_name').type(organizationName);
        cy.get('#post_organization_place').type(organizationPlace);
        cy.get('#post_organization_username').type(organizationUsername);
        cy.get('#post_organization_password').type(organizationPassword);
        cy.wait(500);
        cy.get('#postForm').submit()
    });

});