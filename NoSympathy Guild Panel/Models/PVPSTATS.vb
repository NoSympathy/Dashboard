Public Class PVPSTATS
    'Guild
    Private _pvp_rank As String
    Private _aggregate As Object
    Private _professions As Object
    Private _ladders As Object


    Public Property pvp_rank() As String
        Get
            Return _pvp_rank
        End Get
        Set(value As String)
            Me._pvp_rank = value
        End Set
    End Property

    Public Property aggregate() As Object
        Get
            Return _aggregate
        End Get
        Set(value As Object)
            Me._aggregate = value
        End Set
    End Property
    Public Property professions() As Object
        Get
            Return _professions
        End Get
        Set(value As Object)
            Me._professions = value
        End Set
    End Property

    Public Property Ladders() As Object
        Get
            Return _ladders
        End Get
        Set(value As Object)
            Me._ladders = value
        End Set
    End Property



End Class
