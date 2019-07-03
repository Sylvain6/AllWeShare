const user = {
    email: 'jonathrakoto91400@gmail.com',
    password: 'azertyuiop'
};

const { email, password } = user;

const post = {
    title: 'Spotify Account',
    description: 'Share my Spotify Account',
    organization_name: 'Spotify',
    organization_place: "3",
    organization_username: email,
    organization_password: password
};

const { title, description, organization_name, organization_place, organization_username, organization_password } = post;

describe('Connected: Create Post', function() {
    before(function(){
        cy.exec('php bin/console d:s:u --force && php bin/console d:f:l')
    });
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
    it('Create Post Modal', function() {
        Cypress.Commands.add('loginByCSRF', (title, description, organization_name, organization_place, organization_username, organization_password, csrfToken) => {
            cy.request({
                method: 'POST',
                url: '/',
                failOnStatusCode: false,
                form: true,
                body: {
                    title,
                    description,
                    organization_name,
                    organization_place,
                    organization_username,
                    organization_password,
                    _csrf_token: csrfToken
                }
            })
        });
        cy.request('/login')
            .its('body')
            .then((body) => {
                const $html = Cypress.$(body);
                const csrf = $html.find("input[name=_csrf_token]").val();

                cy.loginByCSRF(title, description, organization_name, organization_place, organization_username, organization_password, csrf)
                    .then((res) => {
                        expect(res.status).to.eq(200);
                        console.log(res.body);
                        // expect(res.body).to.include("");
                    })
            })
    });

});