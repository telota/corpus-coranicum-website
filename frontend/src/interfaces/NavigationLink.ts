import { RouteLocationRaw } from 'vue-router';

interface NavigationLink{
    label: () => string;
    to: undefined | RouteLocationRaw;
    active: string[];
    children?: NavigationLink[];
}

export default NavigationLink;
