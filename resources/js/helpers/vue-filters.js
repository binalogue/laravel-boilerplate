export const capitalize = value => {
  if (!value) {
    return '';
  }

  return value.charAt(0).toUpperCase() + value.slice(1);
};

export const toLowerCase = value => {
  if (!value) {
    return '';
  }

  return value.toString().toLowerCase();
};

export default {
  capitalize,
  toLowerCase,
};
