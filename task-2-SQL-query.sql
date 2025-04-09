# pp - product_packages table
# ph - price_history table
# ppc - product_package_contents table

SELECT
    pp.id AS product_package_id,
    pp.title,
    SUM(
        ppc.quantity *
        (
            SELECT ph.Price
            FROM price_history ph
            WHERE ph.product_id = ppc.product_id
              AND ph.updated_at <= '2024-01-23 12:43:49'  -- Price update date: selects the most recent price update before this timestamp (date (format: YYYY-MM-DD) or timestamp (format: YYYY-MM-DD HH:MM:SS))
            ORDER BY ph.updated_at DESC
            LIMIT 1
        )
    ) AS package_valid_price
FROM product_packages pp
JOIN product_package_contents ppc ON pp.id = ppc.product_package_id
WHERE pp.id = 2  -- Filter by the specific product_package_id
GROUP BY pp.id, pp.title;
