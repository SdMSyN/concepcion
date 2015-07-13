SELECT nombre, COUNT( * ) Total
FROM productos
GROUP BY nombre
HAVING COUNT( * ) >1