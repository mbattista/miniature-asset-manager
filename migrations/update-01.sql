-- Table: public.asset_citrix

-- DROP TABLE public.asset_citrix;

CREATE TABLE public.asset_citrix
(
    id bigint NOT NULL DEFAULT nextval('asset_citrix_id_seq'::regclass),
    asset_id bigint NOT NULL,
    citrix_id bigint NOT NULL,
    CONSTRAINT asset_citrix_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE public.asset_citrix
    OWNER to postgres;

-- SEQUENCE: public.asset_citrix_id_seq

-- DROP SEQUENCE public.asset_citrix_id_seq;

CREATE SEQUENCE public.asset_citrix_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.asset_citrix_id_seq
    OWNER TO postgres;

-- Index: asset_citrix_asset_id_idx

-- DROP INDEX public.asset_citrix_asset_id_idx;

CREATE INDEX asset_citrix_asset_id_idx
    ON public.asset_citrix USING btree
    (asset_id ASC NULLS LAST)
    TABLESPACE pg_default;

-- Index: asset_citrix_citrix_id_idx

-- DROP INDEX public.asset_citrix_citrix_id_idx;

CREATE INDEX asset_citrix_citrix_id_idx
    ON public.asset_citrix USING btree
    (citrix_id ASC NULLS LAST)
    TABLESPACE pg_default;

ALTER TABLE public.asset_citrix
    ADD CONSTRAINT asset_citrix_asset_id_fk FOREIGN KEY (asset_id)
    REFERENCES public.asset (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;

ALTER TABLE public.asset_citrix
    ADD CONSTRAINT asset_citrix_citrix_id_fk FOREIGN KEY (citrix_id)
    REFERENCES public.citrix (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;

ALTER TABLE public.asset_citrix
    ADD CONSTRAINT asset_citrix_unique UNIQUE (asset_id, citrix_id);

ALTER TABLE public.asset_citrix
    ADD COLUMN from_date timestamp with time zone NOT NULL DEFAULT NOW();

ALTER TABLE public.asset_citrix
    ADD COLUMN until timestamp with time zone;

-- Index: asset_citrix_from_idx

-- DROP INDEX public.asset_citrix_from_idx;

CREATE INDEX asset_citrix_from_idx
    ON public.asset_citrix USING btree
    (from_date ASC NULLS LAST)
    TABLESPACE pg_default;

-- Index: asset_citrix_until_idx

-- DROP INDEX public.asset_citrix_until_idx;

CREATE INDEX asset_citrix_until_idx
    ON public.asset_citrix USING btree
    (until ASC NULLS LAST)
    TABLESPACE pg_default;





ALTER TABLE public.places_assets
    ADD COLUMN external_person character varying COLLATE pg_catalog."default";

CREATE INDEX places_assets_external_person_trgm_gin
    ON public.places_assets USING gin
    (external_person gin_trgm_ops)
;

CREATE INDEX fki_places_assets_external_person
    ON public.places_assets USING btree
    (external_person COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;


CREATE INDEX asset_list_from_idx
    ON public.asset_list_table USING btree
    (from_datetimez ASC NULLS LAST)
    TABLESPACE pg_default;

