export const checked = (value) => value;

export const time = (value) => {
  if (!value) {
    return true;
  }

  const regex = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
  return regex.test(value);
};

export default {
  checked,
  time,
};
