export default function routeParamToString(param: string | string[]): string {
  if (typeof (param) === 'string') {
    return param;
  }
  if (param.length > 0) {
    return param.join();
  }
  return 'EmptyRouteParams';
}
