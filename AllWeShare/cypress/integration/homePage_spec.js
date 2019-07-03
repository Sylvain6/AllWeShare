describe('The Home Page', function() {
    it('successfully loads', function() {
        cy.visit('/')
        console.log(res.body)
    })
});