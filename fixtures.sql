-- Фикстуры для БД

-- Функция для удобной генерации чисел в диапазоне
CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
   RETURNS INT AS
$$
BEGIN
    RETURN floor(random() * (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;

CREATE TABLE videos (
    id bigserial PRIMARY KEY,
    title varchar(255) NOT NULL,
    thumbnail varchar(255) NOT NULL,
    duration bigint NOT NULL,

    added_at timestamp NOT NULL DEFAULT now()::timestamp(0)
);

CREATE INDEX ON videos(added_at, id);

-- Просмотры храним отдельно, что бы их можно было обновлять отдельно от основной таблицы
CREATE TABLE videos_views (
     video_id bigint NOT NULL REFERENCES videos(id),
     views_count bigint NOT NULL DEFAULT 0
);

CREATE INDEX ON videos_views(video_id);
CREATE INDEX ON videos_views(views_count, video_id);

-- Генерируем данные
INSERT INTO videos (title, thumbnail, duration, added_at)
SELECT
    'the video number ' || video_id,
    'thumb.jpg',
    random_between(10, 10000),
    (now() + (random() * (now() + '90 days' - now())) + '30 days')::timestamp(0)
FROM generate_series(1, 1000000) video_id;

INSERT INTO videos_views (video_id, views_count)
SELECT
    videos.id,
    random_between(1, 1000000)
FROM videos;
