SELECT FROM_UNIXTIME(p1.time), p2.time, p3.time
FROM
prices p1
LEFT JOIN prices p2
ON p1.time = p2.time - 60
LEFT JOIN prices p3
ON p1.time = p3.time + 60
WHERE (p2.time IS NULL OR p3.time IS NULL)
ORDER BY p1.time ASC;
