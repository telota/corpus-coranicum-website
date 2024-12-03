## Introduction

This folder is for making and running end-2-end tests via Cypress.

## System requirements

- npm
- node version 14 or higher.
- Chrome browser
- The [system requirements for Cypress](https://docs.cypress.io/guides/getting-started/installing-cypress#System-requirements)

## Writing tests

Open cypress with `npx cypress open -c baseUrl=https://corpuscoranicum.de` and click on whatever test you want to run.  Cypress watches for any changes to the test and reruns it.

Notice that you must set the baseUrl.  You can choose what baseUrl, i.e. local, stage, or prod. See the package.json for examples.

## Running tests

All tests can be run, either local, on stage, or on prod, by running `npm run [local|stage|prod]`