interface Contributor {
  name: string;
  role: string;
}

export interface VariantsContribution {
  source: string;
  contributors: Contributor[];
}

export function namesString(names: string[]): string {
  if (names.length === 0) {
    return '';
  }
  if (names.length === 1) {
    return names[0];
  }

  if (names.length === 2) {
    return names.join(' and ');
  }

  if (names.length > 3) {
    const untilAnd = names.slice(1, -1);
    return namesString([untilAnd.join(', '), names.slice[-1]]);
  }

  return '';
}

export function contributorsString(cs: Contributor[]): string {
  let finalString = '';

  const editors = namesString(cs.filter((c) => c.role === 'editor').map((c) => c.name));
  const collaborators = namesString(cs.filter((c) => c.role === 'collaborator').map((c) => c.name));
  const contributors = namesString(
    cs.filter((c) => c.role === 'earlier_contributor').map((c) => c.name),
  );

  if (editors.length > 0) {
    finalString += `edited by ${editors}`;
  }

  if (collaborators.length > 0) {
    if (finalString.length > 0) {
      finalString += ', ';
    }
    finalString += `in collaboration with ${collaborators}`;
  }

  if (contributors.length > 0) {
    if (finalString.length > 0) {
      finalString += ', ';
    }
    finalString += `with earlier contributions by ${contributors}`;
  }

  if (finalString.length > 0) {
    finalString = `: ${finalString}`;
  }

  return finalString;
}
