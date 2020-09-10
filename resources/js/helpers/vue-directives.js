export const scroll = {
  inserted(el, binding) {
    const f = evt => {
      if (binding.value(evt, el)) {
        window.removeEventListener('scroll', f);
      }
    };
    window.addEventListener('scroll', f);
  },
};

export const clickOutside = {
  bind(el, binding, vNode) {
    if (typeof binding.value !== 'function') {
      const compName = vNode.context.name;
      let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`;
      if (compName) {
        warn += `Found in component '${compName}'`;
      }

      console.warn(warn);
    }
    const { bubble } = binding.modifiers;
    const handler = e => {
      if (bubble || (!el.contains(e.target) && el !== e.target)) {
        binding.value(e);
      }
    };
    el.vueClickOutside = handler;
    document.addEventListener('click', handler);
  },

  unbind(el) {
    document.removeEventListener('click', el.vueClickOutside);
    el.vueClickOutside = null;
  },
};

export default {
  scroll,
  clickOutside,
};
