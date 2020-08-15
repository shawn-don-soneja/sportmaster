import Client from 'shopify-buy';

// Initializing a client to return content in the store's primary language
const client = Client.buildClient({
  domain: 'https://sportmaster-bait-and-tackle.myshopify.com/'',
  storefrontAccessToken: 'aad75c99c6746d652cf7b6fc714a0872'
});

// Fetch all products in your shop
client.product.fetchAll().then((products) => {
  // Do something with the products
  console.log(products);
});
