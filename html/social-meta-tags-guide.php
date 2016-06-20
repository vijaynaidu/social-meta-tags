<?php
    defined('ABSPATH') or die();
?>
<div class="wrap">
    <h1>Social Meta Tags for Woocommerce Sites - FAQ</h1>
    <p>Plugin will generate meta tags for product page, which will include `"title", "url", "image", "description"`</p>

    <div>
        <p>
            <h2>How to disable "social meta tags" for individual product?</h2>
            A) Add custom field `<b>smeta_disable</b>` and set value `<b>true</b>` for individual product in wp-admin product edit page to disable generating social meta tags for selected product.
        </p>
        <p>
            <h2>How to overwrite auto generated "social meta tags" for individual product?</h2>
            A) Add any of the following custom fields and set value, that to overwrite social meta tags for selected product.
            <table class="table">
                <thead>
                    <tr>
                        <th>Custom Field Key</th>
                        <th>For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>smeta_og_title</td>
                        <td>Customizing Title</td>
                    </tr>
                    <tr>
                        <td>
                            smeta_og_desc
                        </td>
                        <td>
                            Customizing Description
                            <br />
                            Note: Make sure the length of the string Facebook consider 300 characters, Google plus consider 200 characters & twitter will also consider less 150 chars Appx.
                        </td>
                    </tr>
                    <tr>
                        <td>smeta_og_image</td>
                        <td>
                            Customizing Image
                            <br />
                            Note: Make sure the value should be full image url. Eg. http://www.example.com/product_image.jpg
                        </td>
                    </tr>
                </tbody>
            </table>
        </p>

        <p>
        <h2>Any Comments/ Help Required?</h2>
        We request you to share your thoughts by rating & commenting plugin. It might take less than 5 mins. Feel free to raise support ticket in plugin support form if you require any help.
        </p>

    </div>
</div>