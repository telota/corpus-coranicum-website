import { getVerses } from '@/api/verses';
import { createPopper, Instance, OptionsGeneric, VirtualElement } from '@popperjs/core';
import { ref } from 'vue';
import { parseVerse } from './linker';

const inPopper = ref<boolean>(false);
const newPopper = ref<boolean>(false);
const initialRectangle: DOMRect = {
  x: 0,
  y: 0,
  width: 0,
  height: 0,
  top: 0,
  right: 0,
  bottom: 0,
  left: 0,
  // eslint-disable-next-line @typescript-eslint/no-empty-function
  toJSON: () => {},
};

const virtualElement: VirtualElement = {
  getBoundingClientRect: () => initialRectangle,
};

let instance: null | Instance = null;
let tooltip: null | HTMLElement = null;

function initializePopper(): void {
  tooltip = document.querySelector('#tooltip');

  if (tooltip) {
    instance = createPopper(virtualElement, tooltip, {
      modifiers: [
        {
          name: 'offset',
          options: {
            offset: [0, 8],
          },
        },
      ],
    });
  }
}

// TODO: figure out how to get to Typescript within the ignore flag.
function show(domRect: DOMRect): void {
  virtualElement.getBoundingClientRect = () => domRect;
  if (instance) {
    instance.setOptions((options) => ({
      ...options,
      modifiers: [
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        ...options.modifiers,
        {
          name: 'eventListeners',
          enabled: true,
        },
        {
          name: 'flip',
          enabled: true,
        },
      ],
    }));
    instance.update();
  }

  // Make the tooltip visible
  if (tooltip) {
    tooltip.setAttribute('data-show', '');
  }
  newPopper.value = true;
}

function reallyHide(): void {
  if (tooltip) {
    tooltip.removeAttribute('data-show');
  }
  if (instance) {
    instance.setOptions((options) => ({
      ...options,
      modifiers: [
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        ...options.modifiers,
        {
          name: 'eventListeners',
          enabled: false,
        },
      ],
    }));
  }
}
function hide(): void {
  newPopper.value = false;
  setTimeout(() => {
    if (!inPopper.value && !newPopper.value) {
      reallyHide();
    }
  }, 500);
}

function enteredPopper(): void {
  inPopper.value = true;
}
function leftPopper(): void {
  inPopper.value = false;
  reallyHide();
}

function getData(lang: string, element: Element): void {
  const htmlElement = element as HTMLElement;
  if (htmlElement.dataset.start && htmlElement.dataset.end) {
    const start = parseVerse(htmlElement.dataset.start);
    const end = parseVerse(htmlElement.dataset.end);
    if (start && end) {
      getVerses(lang, {
        start,
        end,
      });
    }
  }
}

function connectQuranRefsToPopper(lang: string): void {
  const elements = document.querySelectorAll('[data-type="koran"');
  elements.forEach((el) => {
    if (el) {
      el.addEventListener('mouseenter', (event: Event) => {
        getData(lang, el);
        el.getBoundingClientRect();
        show(el.getBoundingClientRect());
      });
      el.addEventListener('mouseleave', (event: Event) => {
        hide();
      });
      el.addEventListener('click', () => {
        reallyHide();
      });
    }
  });
}
export {
  initializePopper,
  show,
  reallyHide,
  hide,
  getData,
  inPopper,
  enteredPopper,
  leftPopper,
  connectQuranRefsToPopper,
};
