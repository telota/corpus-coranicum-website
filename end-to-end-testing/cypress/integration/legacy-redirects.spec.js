import urls from '../fixtures/redirects.json';

describe('Legacy urls redirect to the correct url', () => {
	it('Checks for all listed legacy urls ', () => {
		const language = "de"
		cy.visit("/");
		cy.get('#locale-select').select('de');
		urls.forEach((url) => {
			cy.log('Testing redirect', [url.old, url.new]);
			const withLanguage = `/${language}` + url.new;
			cy.visit(url.old);
			cy.url().should('eq', Cypress.config().baseUrl + withLanguage);
		})
	})
})
