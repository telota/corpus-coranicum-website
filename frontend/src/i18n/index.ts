import { createI18n } from 'vue-i18n';
import { Locales } from './locales';

import deFE from './frontend/de.json';
import enFE from './frontend/en.json';
import frFE from './frontend/fr.json';
import de from './database/de.json';
import en from './database/en.json';
import fr from './database/fr.json';

export const messages = {
  [Locales.DE]: { ...de, fe: deFE },
  [Locales.EN]: { ...en, fe: enFE },
  [Locales.FR]: { ...fr, fe: frFE },
};

export const defaultLocale = Locales.DE;

export const i18n = createI18n({
  messages,
  locale: defaultLocale,
  fallbackLocale: defaultLocale,
  globalInjection: true,
});
