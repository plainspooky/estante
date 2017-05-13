CREATE TABLE `tb_emprestimos` (
    `id_emprestimo` int(5) unsigned NOT NULL auto_increment,
    `id_livro` int(5) unsigned NOT NULL default '0',
    `id_usuario` int(5) unsigned NOT NULL default '0',
    `dt_inicio_emprestimo` date NOT NULL default '0000-00-00',
    `dt_fim_emprestimo` date NOT NULL default '0000-00-00',
    PRIMARY KEY  (`id_emprestimo`)
) TYPE=MyISAM COMMENT='tabela relacionando os emprestimos dos livros';

CREATE TABLE `tb_historicos` (
    `id_historico` int(5) unsigned NOT NULL auto_increment,
    `id_livro` int(5) unsigned NOT NULL default '0',
    `id_usuario` int(5) unsigned NOT NULL default '0',
    `tx_usuario_historico` varchar(48) NOT NULL default '',
    `dt_inicio_historico` date NOT NULL default '0000-00-00',
    `dt_fim_historico` date NOT NULL default '0000-00-00',
    `dt_devol_historico` date NOT NULL default '0000-00-00',
    PRIMARY KEY  (`id_historico`)
) TYPE=MyISAM COMMENT='historico de emprestimo dos livros';

CREATE TABLE `tb_livros` (
    `id_livro` int(5) unsigned NOT NULL auto_increment,
    `tx_titulo_livro` varchar(192) NOT NULL default '',
    `tx_autor_livro` varchar(128) NOT NULL default '',
    `tx_isbn_livro` varchar(10) NOT NULL default '',
    `tx_class_livro` varchar(32) NOT NULL default '',
    `tx_pha_livro` varchar(6) NOT NULL default '',
    `tx_editora_livro` varchar(48) NOT NULL default '',
    `tx_cidade_livro` varchar(48) NOT NULL default '',
    `tx_uf_livro` char(2) NOT NULL default '',
    `tx_ed_livro` tinyint(3) unsigned NOT NULL default '0',
    `tx_vol_livro` tinyint(3) unsigned NOT NULL default '0',
    `tx_pat_livro` varchar(8) NOT NULL default '',
    `tx_pag_livro` int(4) unsigned NOT NULL default '0',
    `tx_ano_livro` varchar(4) NOT NULL default '',
    `nm_copia_livro` tinyint(2) unsigned NOT NULL default '0',
    `tx_cip_livro` blob NOT NULL,
    `tx_assunto_livro` varchar(255) NOT NULL default '',
    `st_status_livro` set('A','B','D') NOT NULL default 'A',
    PRIMARY KEY  (`id_livro`)
) TYPE=MyISAM COMMENT='tabela contendo os livros do acervo';

CREATE TABLE `tb_usuarios` (
    `id_usuario` int(5) unsigned NOT NULL auto_increment,
    `tx_nome_usuario` varchar(48) NOT NULL default '',
    `tx_doc_usuario` varchar(16) NOT NULL default '',
    `dt_nasc_usuario` date NOT NULL default '0000-00-00',
    `st_sexo_usuario` set('M','F') NOT NULL default '',
    `nm_escol_usuario` smallint(1) unsigned NOT NULL default '0',
    `tx_tel_res_usuario` varchar(8) NOT NULL default '',
    `tx_tel_cel_usuario` varchar(8) NOT NULL default '',
    `tx_tel_com_usuario` varchar(8) NOT NULL default '',
    `st_status_usuario` set('A','B','D') NOT NULL default '',
    PRIMARY KEY  (`id_usuario`)
) TYPE=MyISAM COMMENT='tabela de usuarios da biblioteca';
