import { RouteLocationNormalizedLoaded } from 'vue-router';

export default function scrollToHash(route: RouteLocationNormalizedLoaded): void {
  if (route.hash) {
    const id = route.hash.replace('#', '');
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({
        behavior: 'smooth',
      });
    }
  }
}
