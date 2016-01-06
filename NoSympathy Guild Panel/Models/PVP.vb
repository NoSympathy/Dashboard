Public Class PVP

    Private _pvp_rank As Integer
    Private _aggregate As String
    Private _professions As String
    Private _ladders As String

    Public Property pvp_rank() As Integer
        Get
            Return Me._pvp_rank
        End Get
        Set(value As Integer)
            Me._pvp_rank = value
        End Set
    End Property

    Public Property aggregate() As String
        Get
            Return Me._aggregate
        End Get
        Set(value As String)
            Me._aggregate = value
        End Set
    End Property

    Public Property professions() As String
        Get
            Return Me._professions
        End Get
        Set(value As String)
            Me._professions = value
        End Set
    End Property

    Public Property ladders() As String
        Get
            Return Me._ladders
        End Get
        Set(value As String)
            Me._ladders = value
        End Set
    End Property


    Public Sub New(pvp_rank As Integer, aggregate As String, professions As String, ladders As String)
        Me.pvp_rank = pvp_rank
        Me.aggregate = aggregate
        Me.professions = professions
        Me.ladders = ladders
    End Sub

End Class
