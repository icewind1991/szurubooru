from szurubooru.search import tokens

class BaseSearchConfig(object):
    SORT_ASC = tokens.SortToken.SORT_ASC
    SORT_DESC = tokens.SortToken.SORT_DESC

    def on_search_query_parsed(self, search_query):
        pass

    def create_filter_query(self):
        raise NotImplementedError()

    def create_count_query(self):
        return self.create_filter_query()

    @property
    def id_column(self):
        return None

    @property
    def anonymous_filter(self):
        return None

    @property
    def special_filters(self):
        return {}

    @property
    def named_filters(self):
        return {}

    @property
    def sort_columns(self):
        return {}
