const firstPage = 2;
const lastPage = 827;
const regex = /(KairoKoranStabi-)(.*)(\/info.json)/;

export function currentPageNumber(url: string): number | undefined {
  const matchPage = url.match(regex);

  if (matchPage && matchPage.length === 4) {
    return +matchPage[2];
  }

  return undefined;
}
function padWithZeros(page: number): string {
  if (page < 10) {
    return `00${page}`;
  }
  if (page < 100) {
    return `0${page}`;
  }

  return `${page}`;
}

function buildUrl(url: string, page: number): string {
  const padded = padWithZeros(page);
  return url.replace(regex, `$1${padded}$3`);
}

export function nextPage(url: string): string | undefined {
  const currentPage = currentPageNumber(url);
  if (currentPage && currentPage < lastPage) {
    return buildUrl(url, currentPage + 1);
  }
  return undefined;
}

export function previousPage(url: string): string | undefined {
  const currentPage = currentPageNumber(url);
  if (currentPage && currentPage > firstPage) {
    return buildUrl(url, currentPage - 1);
  }
  return undefined;
}
