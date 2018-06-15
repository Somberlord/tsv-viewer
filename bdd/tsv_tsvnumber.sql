--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: tsv_tsvnumber; Type: TABLE; Schema: public; Owner: somberlord; Tablespace:
--

CREATE TABLE tsv_tsvnumber (
    uuid integer NOT NULL,
    tsvnumber integer NOT NULL,
    gen smallint NOT NULL,
    doid integer,
    game_name character varying(20)
);


ALTER TABLE public.tsv_tsvnumber OWNER TO somberlord;

--
-- Name: tsv_tsvnumber_pkey; Type: CONSTRAINT; Schema: public; Owner: somberlord; Tablespace:
--

ALTER TABLE ONLY tsv_tsvnumber
    ADD CONSTRAINT tsv_tsvnumber_pkey PRIMARY KEY (uuid, tsvnumber);


--
-- PostgreSQL database dump complete
--
