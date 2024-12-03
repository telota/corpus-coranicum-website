export enum state {
  NotAsked = 'NOT_ASKED',
  Loading = 'LOADING',
  Failure = 'FAILURE',
  Success = 'SUCCESS',
}

type NotAsked = { state: state.NotAsked };
type Loading = { state: state.Loading };
type LoadedData<A> = { state: state.Success; payload: A };
export type Failure = {
  state: state.Failure;
  error: string;
  status: undefined | number;
  url: string;
};

export type RemoteData<A> = NotAsked | Loading | LoadedData<A> | Failure;

export type RemoteDataEntry<A> = { entry: RemoteData<A> };

export function isLoading<A>(data: RemoteData<A>): data is Loading {
  return data.state === state.Loading;
}

export function isLoaded<A>(data: RemoteData<A>): data is LoadedData<A> {
  return data.state === state.Success;
}

export function isNotAsked<A>(data: RemoteData<A>): data is NotAsked {
  return data.state === state.NotAsked;
}

export function isFailure<A>(data: RemoteData<A>): data is Failure {
  return data.state === state.Failure;
}

export function notFound<A>(data: RemoteData<A>): boolean {
  return isFailure(data) && data.status === 404;
}

export function payloadTooLarge<A>(data: RemoteData<A>): boolean {
  return isFailure(data) && data.status === 436;
}
