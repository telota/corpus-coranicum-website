import textContent from '../fixtures/text_content/index.js';

describe('Content appears', () => {
  it('Checks for content in all the languages', () => {
    textContent.forEach((lang) => {
      lang.json.forEach((site) => {
        cy.visit("/" + lang.path + site.path)
        site.content.forEach(content => {
          cy.contains(content);
        })
      })
    })
  })
})
