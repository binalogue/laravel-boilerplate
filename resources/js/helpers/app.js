/**
 * Add SEO meta tags to the current page.
 */
export const addSeoMetaTagsToTheCurrentPage = (meta) => {
  // Set the document (page) title.
  document.title = meta.title;

  // Remove any stale meta tags from the document using the key attribute we
  // set below.
  Array.from(document.querySelectorAll('[data-vue-router-controlled]'))
    .map((el) => el.parentNode.removeChild(el));

  // Turn the meta tag definitions into actual elements in the head and add
  // the meta tags to the document head.
  meta.metaTags.map((tagDef) => {
    const tag = document.createElement('meta');

    Object.keys(tagDef).forEach((key) => {
      tag.setAttribute(key, tagDef[key]);
    });

    // We use this to track which meta tags we create, so we don't interfere
    // with other ones.
    tag.setAttribute('data-vue-router-controlled', '');

    return tag;
  }).forEach((tag) => document.head.appendChild(tag));
};

/**
 * Convert an image URL to base64 encoded JPEG image data.
 */
export const imageToBase64 = (url) => new Promise((resolve) => {
  const xhr = new XMLHttpRequest();
  xhr.onload = () => {
    const reader = new FileReader();
    reader.onloadend = () => {
      resolve(reader.result);
    };
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
});

/**
 * Populate SEO meta tags.
 */
export const populateMetaTags = (
  title, description, image, imageWidth, imageHeight,
) => ({
  title,
  metaTags: [{
    name: 'description',
    content: description,
  },
  {
    property: 'og:title',
    content: title,
  },
  {
    property: 'og:description',
    content: description,
  },
  {
    property: 'og:url',
    content: window.location.href,
  },
  {
    property: 'og:image',
    content: image,
  },
  {
    property: 'og:image:secure_url',
    content: image,
  },
  {
    property: 'og:image:width',
    content: imageWidth,
  },
  {
    property: 'og:image:height',
    content: imageHeight,
  },
  {
    property: 'twitter:title',
    content: title,
  },
  {
    property: 'twitter:description',
    content: description,
  },
  {
    property: 'twitter:image',
    content: image,
  },
  ],
});

export default {
  addSeoMetaTagsToTheCurrentPage,
  imageToBase64,
  populateMetaTags,
};
