import { ref, Ref, watch } from 'vue';
import axios from 'axios';
import { state, RemoteData, Failure, notFound, payloadTooLarge } from '@/interfaces/RemoteData';
import { RouteLocationNormalizedLoaded } from 'vue-router';

axios.defaults.baseURL = process.env.VUE_APP_BACKEND_URL || 'http://localhost:8003';

// axios.defaults.timeout = 20000;

const payloads: Map<string, any> = new Map();
const errors: Ref<Failure[]> = ref<Failure[]>([]);

/**
 * Generic api get call
 */
function get<T>(url: string, data: Ref<RemoteData<T>>): void {
  if (payloads.has(url)) {
    data.value = {
      state: state.Success,
      payload: payloads.get(url),
    };
    return;
  }

  data.value = { state: state.Loading };

  // https://stackoverflow.com/questions/36690451/timeout-feature-in-the-axios-library-is-not-working

  axios
    .get(url)
    .then((res) => {
      payloads.set(url, res.data.data);
      data.value = {
        state: state.Success,
        payload: res.data.data,
      };
    })
    .catch((err) => {
      const error: Failure = {
        url,
        state: state.Failure,
        error: String(err.message),
        status: +err?.response?.status,
      };

      data.value = error;
      if (!notFound(error) && !payloadTooLarge(error)) {
        errors.value.push(error);
      }
    });
}

function getAndGetOnNewLanguage<D>(
  url: string,
  data: Ref<RemoteData<D>>,
  route: RouteLocationNormalizedLoaded,
): void {
  get(url, data);
  const routeName = route.name;
  watch(
    () => route.params.lang,
    () => {
      if (route.name === routeName) {
        const regex = /\/language\/.*?\//;
        const newUrl = url.replace(regex, `/language/${route.params.lang}/`);
        get(newUrl, data);
      }
    },
  );
}

function clearErrors(): void {
  errors.value = [];
}

export { get, getAndGetOnNewLanguage, errors, clearErrors };
