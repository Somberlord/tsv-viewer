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
-- Name: tsv_pokemon; Type: TABLE; Schema: public; Owner: somberlord; Tablespace:
--

CREATE TABLE tsv_pokemon (
    game_name character varying(30),
    save_nb integer NOT NULL,
    box_nb smallint NOT NULL,
    line smallint NOT NULL,
    "row" smallint NOT NULL,
    pokemon character varying(30),
    esv integer,
    gen smallint,
    id_tsv integer NOT NULL
);


ALTER TABLE public.tsv_pokemon OWNER TO somberlord;

--
-- Name: tsv_pokemon_pkey; Type: CONSTRAINT; Schema: public; Owner: somberlord; Tablespace:
--

ALTER TABLE ONLY tsv_pokemon
    ADD CONSTRAINT tsv_pokemon_pkey PRIMARY KEY (save_nb, box_nb, line, "row", id_tsv);


--
-- PostgreSQL database dump complete
--
